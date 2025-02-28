import Foundation

final class CreateLedgerOperation: ApiOperation<CreateLedgerRequest, CreateLedgerResponse> {
    init(request body: CreateLedgerRequest) {
        super.init(method: .post, path: "/ledgers", body: body)
    }
}

struct CreateLedgerRequest: ApiMultipartFormDataRequest {
    let boundary = UUID().uuidString

    let name: String
    let currency: Currency.Reference
    let picture: Data?
    let users: [User.Reference]
}

struct CreateLedgerResponse: ApiActionResponse, ApiDataResponse {
    let message: String
    let data: Ledger
}
