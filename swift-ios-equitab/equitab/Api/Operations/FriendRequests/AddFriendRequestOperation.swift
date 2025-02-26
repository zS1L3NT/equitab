import Foundation

final class AddFriendRequestOperation: ApiOperation<ApiRequest, AddFriendRequestResponse> {
    init(id: Int) {
        super.init(method: .post, path: "/friends/requests/\(id)")
    }
}

struct AddFriendRequestResponse: ApiActionResponse {
    let message: String
}
