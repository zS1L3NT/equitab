import Foundation

enum HttpMethod: String {
    case get = "get"
    case post = "post"
    case put = "put"
    case delete = "delete"
}

class ApiOperation<Request: ApiRequest, Response: ApiResponse> {
    let method: HttpMethod
    let path: String
    let query: [String: String]
    let headers: [String: String]
    let body: Request?

    init(
        method: HttpMethod,
        path: String,
        query: [String: String] = [:],
        headers: [String: String] = [:],
        body: Request? = nil
    ) {
        self.method = method
        self.path = path
        self.query = query
        self.headers = headers
        self.body = body
    }

    func execute(
        completion: @Sendable @escaping (Result<Response, ApiErrorResponse>) -> Void
    ) {
        guard let API_URL = ProcessInfo.processInfo.environment["API_URL"] else {
            return completion(
                .failure(
                    ApiErrorResponse(
                        type: "Client error",
                        message: "Cannot find API URL in environment"
                    )
                )
            )
        }

        guard
            let url = URL(string: API_URL + path)?.appending(
                queryItems: query.map { URLQueryItem(name: $0.key, value: $0.value) }
            )
        else {
            return completion(
                .failure(
                    ApiErrorResponse(
                        type: "Client error",
                        message: "Failed to build URL"
                    )
                )
            )
        }

        var request = URLRequest(url: url)
        request.httpMethod = method.rawValue

        // Only HTTP POST can take FormData
        if body is any ApiMultipartFormDataRequest {
            request.httpMethod = HttpMethod.post.rawValue
        }

        request.addValue("application/json", forHTTPHeaderField: "Accept")
        for (key, value) in headers {
            request.addValue(value, forHTTPHeaderField: key)
        }

        switch body {
        case let data as Encodable:
            request.setValue(
                "application/json",
                forHTTPHeaderField: "Content-Type"
            )
            do {
                request.httpBody = try JSONEncoder().encode(data)
            } catch let error {
                return completion(
                    .failure(
                        ApiErrorResponse(
                            type: "Client error",
                            message: "Failed to encode json data: \(error.localizedDescription)"
                        )
                    )
                )
            }
        case let formdata as any ApiMultipartFormDataRequest:
            request.setValue(
                "multipart/form-data; boundary=\(formdata.boundary)",
                forHTTPHeaderField: "Content-Type"
            )
            do {
                // Pass in HTTP Method to soft override
                request.httpBody = try formdata.toData(method: method)
            } catch let error {
                return completion(
                    .failure(
                        ApiErrorResponse(
                            type: "Client error",
                            message: "Failed to encode form data: \(error.localizedDescription)"
                        )
                    )
                )
            }
        default:
            return completion(
                .failure(
                    ApiErrorResponse(
                        type: "Client error",
                        message: "Unsupported body type"
                    )
                )
            )
        }

        URLSession.shared.dataTask(with: request) { data, _, error in
            if let error {
                return completion(
                    .failure(
                        ApiErrorResponse(
                            type: "Unknown error",
                            message: error.localizedDescription
                        )
                    )
                )
            }

            if let data {
                if let error = try? JSONDecoder().decode(ApiErrorResponse.self, from: data) {
                    return completion(.failure(error))
                }

                if let response = try? JSONDecoder().decode(Response.self, from: data) {
                    return completion(.success(response))
                }
            }

            return completion(
                .failure(
                    ApiErrorResponse(
                        type: "Unknown API Response Schema",
                        message:
                            "The API Response did not match the expected response schema: \(String(data: data ?? Data(), encoding: .utf8) ?? "")"
                    )
                )
            )
        }.resume()
    }
}
