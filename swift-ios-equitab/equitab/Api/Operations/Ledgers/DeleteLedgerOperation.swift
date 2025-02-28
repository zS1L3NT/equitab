import Foundation

final class DeleteLedgerOperation: ApiOperation<ApiEmptyRequest, DeleteLedgerResponse> {
    init(ledgerId: Int) {
        super.init(method: .delete, path: "/ledgers/\(ledgerId)")
    }
}

struct DeleteLedgerResponse: ApiActionResponse {
    let message: String
}
