import Foundation

enum FriendRequestType: String {
    case incoming
    case outgoing
}

final class ListFriendRequestsOperation: ApiOperation<ApiEmptyRequest, ListFriendRequestsResponse> {
    init(type: FriendRequestType) {
        super.init(method: .get, path: "/friends/requests", query: ["type": type.rawValue])
    }
}

struct ListFriendRequestsResponse: ApiPaginationResponse {
    let data: [User]
    let meta: ApiPaginationMeta
}
