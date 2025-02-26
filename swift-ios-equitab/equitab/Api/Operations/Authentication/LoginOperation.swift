import Foundation

final class LoginOperation: ApiOperation<LoginRequest, LoginResponse> {
    init(request body: LoginRequest) {
        super.init(method: .post, path: "/auth/login", body: body)
    }
}

struct LoginRequest: Encodable {
    let username: String
    let password: String
    let deviceName: String

    private enum CodingKeys: String, CodingKey {
        case username, password
        case deviceName = "device_name"
    }
}

struct LoginResponse: ApiActionResponse, ApiDataResponse {
    let message: String
    let data: User
}
