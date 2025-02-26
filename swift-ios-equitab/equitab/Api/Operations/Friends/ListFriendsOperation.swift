import Foundation

final class ListFriendsOperation: ApiOperation<ApiRequest, ListFriendsResponse> {
    init() {
        super.init(method: .get, path: "/friends")
    }
}

struct ListFriendsResponse: ApiPaginationResponse {
    let data: [User]
    let meta: ApiPaginationMeta
}
