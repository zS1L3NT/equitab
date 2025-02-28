import Foundation

final class DeleteTransactionOperation: ApiOperation<ApiEmptyRequest, DeleteTransactionResponse> {
    init(ledgerId: Int, transactionId: Int) {
        super.init(method: .delete, path: "/ledgers/\(ledgerId)/transactions/\(transactionId)")
    }
}

struct DeleteTransactionResponse: ApiActionResponse {
    let message: String
}
