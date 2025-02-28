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

    enum CodingKeys: String, CodingKey {
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

    enum CodingKeys: String, CodingKey {
        case page = "current_page"
        case pages = "last_page"
        case total
    }
}
