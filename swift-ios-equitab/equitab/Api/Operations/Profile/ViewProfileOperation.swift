import Foundation

final class ViewProfileOperation: ApiOperation<ApiEmptyRequest, ViewProfileResponse> {
    init() {
        super.init(method: .get, path: "/profile")
    }
}

struct ViewProfileResponse: ApiDataResponse {
    let data: User
}
