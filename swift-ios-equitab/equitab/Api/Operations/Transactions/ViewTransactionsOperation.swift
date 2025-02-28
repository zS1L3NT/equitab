import Foundation

final class ViewTransactionsOperation: ApiOperation<ApiEmptyRequest, ViewTransactionsResponse> {
    init(ledgerId: Int, transactionId: Int) {
        super.init(method: .get, path: "/ledgers/\(ledgerId)/transactions/\(transactionId)")
    }
}

struct ViewTransactionsResponse: ApiDataResponse {
    let data: Transaction
}
