import Foundation

final class RemoveFriendOperation: ApiOperation<ApiEmptyRequest, RemoveFriendResponse> {
    init(friendId: String) {
        super.init(method: .delete, path: "/friends/\(friendId)")
    }
}

struct RemoveFriendResponse: ApiActionResponse {
    let message: String
}
