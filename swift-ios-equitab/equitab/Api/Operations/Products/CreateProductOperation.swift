import Foundation

final class CreateProductOperation: ApiOperation<CreateProductRequest, CreateProductResponse> {
    init(ledgerId: Int, transactionId: Int, request body: CreateProductRequest) {
        super.init(
            method: .post,
            path: "/ledgers/\(ledgerId)/transactions/\(transactionId)/products",
            body: body
        )
    }
}

struct CreateProductRequest: ApiRequest {
    let name: String
    let index: Int
    let quantity: Int
    let cost: Double
    let owers: [User.Reference.WithAggregate]
}

struct CreateProductResponse: ApiActionResponse, ApiDataResponse {
    let message: String
    let data: Product
}
