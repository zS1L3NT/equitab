import Foundation

final class ListLedgersOperation: ApiOperation<ApiEmptyRequest, ListLedgersResponse> {
    init() {
        super.init(method: .get, path: "/ledgers")
    }
}

struct ListLedgersResponse: ApiPaginationResponse {
    let data: [Ledger]
    let meta: ApiPaginationMeta
}
