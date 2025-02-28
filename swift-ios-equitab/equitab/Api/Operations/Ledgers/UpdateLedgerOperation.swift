import Foundation

final class UpdateLedgerOperation: ApiOperation<UpdateLedgerRequest, UpdateLedgerResponse> {
    init(ledgerId: Int, request body: UpdateLedgerRequest) {
        super.init(method: .put, path: "/ledgers/\(ledgerId)", body: body)
    }
}

struct UpdateLedgerRequest: ApiMultipartFormDataRequest {
    let keyedBy = Ledger.CodingKeys.self
    let boundary = UUID().uuidString

    let name: String?
    let currency: Currency.Reference?
    let picture: Data?
    let users: [User.Reference]?
}

struct UpdateLedgerResponse: ApiActionResponse, ApiDataResponse {
    let message: String
    let data: Ledger
}
