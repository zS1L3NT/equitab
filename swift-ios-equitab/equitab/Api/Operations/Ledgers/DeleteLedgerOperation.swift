import Foundation

final class DeleteLedgerOperation: ApiOperation<ApiEmptyRequest, DeleteLedgerResponse> {
    init(id: Int) {
        super.init(method: .delete, path: "/ledgers/\(id)")
    }
}

struct DeleteLedgerResponse: ApiActionResponse {
    let message: String
}
