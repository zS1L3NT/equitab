import Foundation

final class ViewLedgerOperation: ApiOperation<ApiEmptyRequest, ViewLedgerResponse> {
    init(ledgerId: Int) {
        super.init(method: .get, path: "/ledgers/\(ledgerId)")
    }
}

struct ViewLedgerResponse: ApiDataResponse {
    let data: Ledger
}
