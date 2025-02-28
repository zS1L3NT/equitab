import Foundation

final class RemoveFriendRequestOperation: ApiOperation<ApiEmptyRequest, RemoveFriendRequestResponse>
{
    init(friendRequestId: Int) {
        super.init(method: .delete, path: "/friends/requests/\(friendRequestId)")
    }
}

struct RemoveFriendRequestResponse: ApiActionResponse {
    let message: String
}
