import Foundation

final class ViewFriendOperation: ApiOperation<ApiRequest, ViewFriendResponse> {
    init(id: Int) {
        super.init(method: .get, path: "/friends/\(id)")
    }
}

struct ViewFriendResponse: ApiDataResponse {
    let data: User
}
