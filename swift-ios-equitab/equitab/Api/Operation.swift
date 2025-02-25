import Foundation

let API_URL = ProcessInfo.processInfo.environment["API_URL"]!

enum HttpMethod: String {
    case get = "get"
    case post = "post"
    case put = "put"
    case delete = "delete"
}

enum ApiResponse<ResponseData: Decodable>: Decodable {
    case Error(ApiErrorResponse)
    case Pagination(ApiPaginationResponse<ResponseData>)
    case Data(ApiDataResponse<ResponseData>)

    init(from decoder: Decoder) throws {
        let container = try! decoder.singleValueContainer()
        if let error = try? container.decode(ApiErrorResponse.self) {
            self = .Error(error)
        } else if let pagination = try? container.decode(ApiPaginationResponse<ResponseData>.self) {
            self = .Pagination(pagination)
        } else if let data = try? container.decode(ApiDataResponse<ResponseData>.self) {
            self = .Data(data)
        } else {
            fatalError("Invalid response")
        }
    }
}

struct ApiErrorResponse: Decodable {
    let error: Error

    struct Error: Decodable {
        let type: String
        let message: String
        let fields: [String: [String]]?
    }

    init(type: String, message: String) {
        self.error = Error(type: type, message: message, fields: nil)
    }

    init(type: String, message: String, fields: [String: [String]]) {
        self.error = Error(type: type, message: message, fields: fields)
    }
}

struct ApiPaginationResponse<ResponseData: Decodable>: Decodable {
    let data: ResponseData
    let meta: Meta

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

struct ApiDataResponse<ResponseData: Decodable>: Decodable {
    let message: String?
    let data: ResponseData
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
        completion: @Sendable @escaping (ApiResponse<ResponseData>) -> Void
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
                    .Error(
                        ApiErrorResponse(
                            type: "Unknown error",
                            message: error!.localizedDescription
                        )
                    )
                )
            }

            guard
                let response = try? JSONDecoder().decode(ApiResponse<ResponseData>.self, from: data)
            else {
                return completion(
                    .Error(
                        ApiErrorResponse(
                            type: "Parsing error",
                            message: String(data: data, encoding: .utf8) ?? ""
                        )
                    )
                )
            }

            completion(response)
        }.resume()
    }
}
