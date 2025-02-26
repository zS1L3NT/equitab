import Foundation

final class UpdateProfileOperation: ApiOperation<ApiRequest, UpdateProfileResponse> {
    init(request body: UpdateProfileRequest) {
        super.init(method: .put, path: "/profile")
    }
}

struct UpdateProfileRequest: Encodable {
    // TODO User update needs multipart/form-data
}

struct UpdateProfileResponse: ApiActionResponse, ApiDataResponse {
    let message: String
    let data: User
}
