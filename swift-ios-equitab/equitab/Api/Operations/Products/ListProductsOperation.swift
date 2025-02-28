import Foundation

final class ListProductsOperation: ApiOperation<ApiEmptyRequest, ListProductsResponse> {
    init(ledgerId: Int, transactionId: Int) {
        super.init(
            method: .get, path: "/ledgers/\(ledgerId)/transactions/\(transactionId)/products"
        )
    }
}

struct ListProductsResponse: ApiPaginationResponse {
    let data: [Product]
    let meta: ApiPaginationMeta
}
