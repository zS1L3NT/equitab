import Foundation

final class ViewFriendOperation: ApiOperation<ApiEmptyRequest, ViewFriendResponse> {
    init(friendId: Int) {
        super.init(method: .get, path: "/friends/\(friendId)")
    }
}

struct ViewFriendResponse: ApiDataResponse {
    let data: User
}
