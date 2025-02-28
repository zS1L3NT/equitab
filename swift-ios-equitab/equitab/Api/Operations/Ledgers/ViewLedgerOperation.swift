import Foundation

final class ViewLedgerOperation: ApiOperation<ApiEmptyRequest, ViewLedgerResponse> {
    init(id: Int) {
        super.init(method: .get, path: "/ledgers/\(id)")
    }
}

struct ViewLedgerResponse: ApiDataResponse {
    let data: Ledger
}
