import Foundation

final class UpdateTransactionOperation: ApiOperation<
    UpdateTransactionRequest, UpdateTransactionResponse
>
{
    init(ledgerId: Int, transactionId: Int, request body: UpdateTransactionRequest) {
        super.init(
            method: .put, path: "/ledgers/\(ledgerId)/transactions/\(transactionId)", body: body
        )
    }
}

struct UpdateTransactionRequest: ApiRequest {
    let name: String?
    let cost: Double?
    let location: String?
    let datetime: Date?
    let category: Category.Reference?
    let payer: User.Reference?
    let owers: [User.Reference.WithAggregate]?
}

struct UpdateTransactionResponse: ApiActionResponse, ApiDataResponse {
    let message: String
    let data: Transaction
}
