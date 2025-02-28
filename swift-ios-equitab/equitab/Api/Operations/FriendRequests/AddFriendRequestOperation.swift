import Foundation

final class AddFriendRequestOperation: ApiOperation<ApiEmptyRequest, AddFriendRequestResponse> {
    init(friendRequestId: Int) {
        super.init(method: .post, path: "/friends/requests/\(friendRequestId)")
    }
}

struct AddFriendRequestResponse: ApiActionResponse {
    let message: String
}
