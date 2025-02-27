import Foundation

final class UpdateProfileOperation: ApiOperation<UpdateProfileRequest, UpdateProfileResponse> {
    init(request body: UpdateProfileRequest) {
        super.init(method: .put, path: "/profile", body: body)
    }
}

struct UpdateProfileRequest: ApiMultipartFormDataRequest {
    let keyedBy = User.CodingKeys.self
    let boundary = UUID().uuidString

    let id: Int
    let username: String?
    let phoneNumber: String?
    let picture: Data?
    let password: String?
    let passwordConfirmation: String?
}

struct UpdateProfileResponse: ApiActionResponse, ApiDataResponse {
    let message: String
    let data: User
}
