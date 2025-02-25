import Foundation

final class LoginOperation: ApiOperation<LoginRequest, LoginResponse> {
    init(request: LoginRequest) {
        super.init(method: .post, path: "/login", request: request)
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

struct LoginResponse: Decodable {
    let message: String
    let user: User
}
