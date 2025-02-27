import Foundation

final class RemoveFriendOperation: ApiOperation<ApiEmptyRequest, RemoveFriendResponse> {
    init(id: String) {
        super.init(method: .delete, path: "/friends/\(id)")
    }
}

struct RemoveFriendResponse: ApiActionResponse {
    let message: String
}
