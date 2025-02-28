import Foundation

final class UpdateProductOperation: ApiOperation<UpdateProductRequest, UpdateProductResponse> {
    init(ledgerId: Int, transactionId: Int, productId: Int, request body: UpdateProductRequest) {
        super.init(
            method: .put,
            path: "/ledgers/\(ledgerId)/transactions/\(transactionId)/products/\(productId)",
            body: body
        )
    }
}

struct UpdateProductRequest: ApiRequest {
    let name: String?
    let index: Int?
    let quantity: Int?
    let cost: Double?
    let owers: [User.Reference.WithAggregate]?
}

struct UpdateProductResponse: ApiActionResponse, ApiDataResponse {
    let message: String
    let data: Product
}
