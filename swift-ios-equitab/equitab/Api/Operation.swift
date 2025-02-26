import Foundation

let API_URL = ProcessInfo.processInfo.environment["API_URL"]!

enum HttpMethod: String {
    case get = "get"
    case post = "post"
    case put = "put"
    case delete = "delete"
}

struct ApiRequest: Encodable {}

struct ApiErrorResponse: Error, Decodable {
    let type: String
    let message: String
    let fields: [String: [String]]?

    init(type: String, message: String) {
        self.type = type
        self.message = message
        self.fields = nil
    }

    private enum CodingKeys: String, CodingKey {
        case error
    }

    init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        let error = try! container.decode(CustomError.self, forKey: .error)
        type = error.type
        message = error.message
        fields = error.fields
    }

    struct CustomError: Decodable {
        let type: String
        let message: String
        let fields: [String: [String]]?

        private enum CodingKeys: String, CodingKey {
            case type, message, fields
        }

        init(type: String, message: String, fields: [String: [String]]?) {
            self.type = type
            self.message = message
            self.fields = fields
        }

        init(from decoder: Decoder) throws {
            let container = try decoder.container(keyedBy: CodingKeys.self)
            type = try container.decode(String.self, forKey: .type)
            message = try container.decode(String.self, forKey: .message)
            fields = try container.decodeIfPresent([String: [String]].self, forKey: .fields)
        }
    }
}

struct ApiDataResponse<ResponseData: Decodable>: Decodable {
    let message: String?
    let data: ResponseData
    let meta: Meta?

    struct Meta: Decodable {
        let page: Int
        let pages: Int
        let total: Int

        private enum CodingKeys: String, CodingKey {
            case page = "current_page"
            case pages = "last_page"
            case total
        }
    }
}

class ApiOperation<RequestBody: Encodable, ResponseData: Decodable> {
    let method: HttpMethod
    let path: String
    let query: [String: String]?
    let headers: [String: String]?
    let body: RequestBody?

    init(
        method: HttpMethod,
        path: String,
        query: [String: String]? = nil,
        headers: [String: String]? = nil,
        body: RequestBody? = nil
    ) {
        self.method = method
        self.path = path
        self.query = query
        self.headers = headers
        self.body = body
    }

    func execute(
        completion: @Sendable @escaping (Result<ApiDataResponse<ResponseData>, ApiErrorResponse>) ->
            Void
    ) {
        var components = URLComponents(
            url: URL(string: API_URL + path)!,
            resolvingAgainstBaseURL: false
        )!

        if let query = self.query {
            components.queryItems = query.map { URLQueryItem(name: $0.key, value: $0.value) }
        }

        var request = URLRequest(url: components.url!)
        request.httpMethod = method.rawValue
        request.addValue("application/json", forHTTPHeaderField: "Content-Type")
        request.addValue("application/json", forHTTPHeaderField: "Accept")

        if let query = self.query {
            var components = URLComponents(string: API_URL + path)!
            components.queryItems = query.map { URLQueryItem(name: $0.key, value: $0.value) }
            request.url = components.url
        }

        if let headers = self.headers {
            for (key, value) in headers {
                request.addValue(value, forHTTPHeaderField: key)
            }
        }

        if let body = self.body {
            request.httpBody = try! JSONEncoder().encode(body)
        }

        URLSession.shared.dataTask(with: request) { data, _, error in
            guard let data = data else {
                return completion(
                    .failure(
                        ApiErrorResponse(
                            type: "Unknown error",
                            message: error!.localizedDescription
                        )
                    )
                )
            }

            if let error = try? JSONDecoder().decode(
                ApiErrorResponse.self, from: data)
            {
                return completion(.failure(error))
            }

            if let response = try? JSONDecoder().decode(
                ApiDataResponse<ResponseData>.self, from: data)
            {
                return completion(.success(response))
            }

            return completion(
                .failure(
                    ApiErrorResponse(
                        type: "Unknown error",
                        message: "An unknown error occurred"
                    )
                )
            )
        }.resume()
    }
}
