import Foundation

protocol ApiRequest {}

protocol ApiJsonRequest: ApiRequest, Encodable {}

struct ApiEmptyRequest: ApiJsonRequest {}

protocol ApiResponse: Decodable {}

struct ApiErrorResponse: ApiResponse, Error {
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
        let error = try container.decode(CustomError.self, forKey: .error)
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

protocol ApiActionResponse: ApiResponse {
    var message: String { get }
}

protocol ApiDataResponse: ApiResponse {
    associatedtype Data = Decodable
    var data: Data { get }
}

protocol ApiPaginationResponse: ApiResponse {
    associatedtype Item = Decodable
    var data: [Item] { get }
    var meta: ApiPaginationMeta { get }
}

struct ApiPaginationMeta: Decodable {
    let page: Int
    let pages: Int
    let total: Int

    private enum CodingKeys: String, CodingKey {
        case page = "current_page"
        case pages = "last_page"
        case total
    }
}
