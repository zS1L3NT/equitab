import Foundation

final class ListFriendsOperation: ApiOperation<ApiEmptyRequest, ListFriendsResponse> {
    init() {
        super.init(method: .get, path: "/friends")
    }
}

struct ListFriendsResponse: ApiPaginationResponse {
    let data: [User]
    let meta: ApiPaginationMeta
}
