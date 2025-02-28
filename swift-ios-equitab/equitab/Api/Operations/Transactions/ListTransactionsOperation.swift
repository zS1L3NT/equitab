import Foundation

final class ListTransactionsOperation: ApiOperation<ApiEmptyRequest, ListTransactionsResponse> {
    init(ledgerId: Int) {
        super.init(method: .get, path: "/ledgers/\(ledgerId)/transactions")
    }
}

struct ListTransactionsResponse: ApiPaginationResponse {
    let data: [Transaction]
    let meta: ApiPaginationMeta
}
