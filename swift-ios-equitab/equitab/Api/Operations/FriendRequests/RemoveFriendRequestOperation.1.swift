import Foundation

final class RemoveFriendRequestOperation: ApiOperation<ApiEmptyRequest, RemoveFriendRequestResponse> {
    init(id: Int) {
        super.init(method: .delete, path: "/friends/requests/\(id)")
    }
}

struct RemoveFriendRequestResponse: ApiActionResponse {
    let message: String
}
