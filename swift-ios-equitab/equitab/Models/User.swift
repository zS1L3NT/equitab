import Foundation
import SwiftData

@Model
final class User: Decodable {
    @Attribute(.unique) var id: Int
    var username: String?
    var phoneNumber: String?
    var picture: String?
    var aggregate: Double?

    struct Reference {
        var id: Int
    }

    enum CodingKeys: String, CodingKey {
        case id, username
        case phoneNumber = "phone_number"
        case picture, password
        case passwordConfirmation = "password_confirmation"
        case aggregate
    }

    init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        id = try container.decode(Int.self, forKey: .id)
        username = try container.decodeIfPresent(String.self, forKey: .username)
        phoneNumber = try container.decodeIfPresent(String.self, forKey: .phoneNumber)
        picture = try container.decodeIfPresent(String.self, forKey: .picture)
        aggregate = try container.decodeIfPresent(Double.self, forKey: .aggregate)
    }
}
