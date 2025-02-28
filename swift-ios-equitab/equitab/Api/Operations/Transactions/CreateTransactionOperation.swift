import Foundation

final class CreateTransactionOperation: ApiOperation<
    CreateTransactionRequest, CreateTransactionResponse
>
{
    init(ledgerId: Int, request body: CreateTransactionRequest) {
        super.init(method: .post, path: "/ledgers/\(ledgerId)/transactions", body: body)
    }
}

struct CreateTransactionRequest: ApiRequest {
    let name: String
    let cost: Double
    let location: String?
    let datetime: Date
    let category: Category.Reference
    let payer: User.Reference
    let owers: [User.Reference.WithAggregate]
}

struct CreateTransactionResponse: ApiActionResponse, ApiDataResponse {
    let message: String
    let data: Transaction
}
