import Foundation

final class LogoutOperation: ApiOperation<ApiEmptyRequest, LogoutResponse> {
    init() {
        super.init(method: .post, path: "/auth/logout")
    }
}

struct LogoutResponse: ApiActionResponse {
    let message: String
}
