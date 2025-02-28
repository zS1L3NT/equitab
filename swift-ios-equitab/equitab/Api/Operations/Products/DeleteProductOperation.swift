import Foundation

final class DeleteProductOperation: ApiOperation<ApiEmptyRequest, DeleteProductResponse> {
    init(ledgerId: Int, transactionId: Int, productId: Int) {
        super.init(
            method: .delete,
            path: "/ledgers/\(ledgerId)/transactions/\(transactionId)/products/\(productId)"
        )
    }
}

struct DeleteProductResponse: ApiActionResponse {
    let message: String
}
