import Foundation

let API_URL = ProcessInfo.processInfo.environment["API_URL"]!

enum HttpMethod: String {
    case get = "get"
    case post = "post"
    case put = "put"
    case delete = "delete"
}

struct ApiErrorResponse: Error, Decodable {
    let error: Data

    init(type: String, message: String) {
        self.error = Data(type: type, message: message, fields: nil)
    }

    init(type: String, message: String, fields: [String: [String]]) {
        self.error = Data(type: type, message: message, fields: fields)
    }

    private enum CodingKeys: String, CodingKey {
        case error
    }

    init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        error = try! container.decode(Data.self, forKey: .error)
    }

    struct Data: Decodable {
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
            fields = try container.decodeIfPresent(
                [String: [String]].self, forKey: .fields)
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
    var request: RequestBody
    var method: HttpMethod
    var headers: [String: String] = [:]
    var path: String

    init(method: HttpMethod, path: String, request: RequestBody) {
        self.request = request
        self.method = method
        self.path = path
    }

    func execute(
        completion: @Sendable @escaping (Result<ApiDataResponse<ResponseData>, ApiErrorResponse>) ->
            Void
    ) {
        var request = URLRequest(url: URL(string: API_URL + path)!)
        request.httpBody = try! JSONEncoder().encode(self.request)
        request.httpMethod = method.rawValue
        request.addValue("application/json", forHTTPHeaderField: "Content-Type")
        request.addValue("application/json", forHTTPHeaderField: "Accept")
        for (key, value) in headers {
            request.addValue(value, forHTTPHeaderField: key)
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

            if let response = try? JSONDecoder().decode(
                ApiDataResponse<ResponseData>.self, from: data)
            {
                return completion(.success(response))
            }

            if let error = try? JSONDecoder().decode(
                ApiErrorResponse.self, from: data)
            {
                return completion(.failure(error))
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
