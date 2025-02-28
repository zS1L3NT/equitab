import Foundation

final class LoginOperation: ApiOperation<LoginRequest, LoginResponse> {
    init(request body: LoginRequest) {
        super.init(method: .post, path: "/auth/login", body: body)
    }
}

struct LoginRequest: ApiJsonRequest {
    let username: String
    let password: String
    let deviceName: String

    enum CodingKeys: String, CodingKey {
        case username, password
        case deviceName = "device_name"
    }
}

struct LoginResponse: ApiActionResponse, ApiDataResponse {
    let message: String
    let data: Data

    struct Data: Decodable {
        let token: String
        let user: User
    }
}
