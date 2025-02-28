import Foundation

final class ViewProductsOperation: ApiOperation<ApiEmptyRequest, ViewProductsResponse> {
    init(ledgerId: Int, transactionId: Int, productId: Int) {
        super.init(
            method: .get,
            path: "/ledgers/\(ledgerId)/transactions/\(transactionId)/products/\(productId)"
        )
    }
}

struct ViewProductsResponse: ApiDataResponse {
    let data: Product
}
