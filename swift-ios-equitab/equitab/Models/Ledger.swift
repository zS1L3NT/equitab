import Foundation
import SwiftData

@Model
final class Ledger: Codable {
    @Attribute(.unique) var id: Int
    var name: String
    var picture: String
    var aggregate: Int?
    var currency: Currency
    var users: [User]

    private enum CodingKeys: String, CodingKey {
        case id, name, picture, aggregate, currency, users
    }

    init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        id = try container.decode(Int.self, forKey: .id)
        name = try container.decode(String.self, forKey: .name)
        picture = try container.decode(String.self, forKey: .picture)
        aggregate = try container.decodeIfPresent(Int.self, forKey: .picture)
        currency = try container.decode(Currency.self, forKey: .currency)
        users = try container.decode([User].self, forKey: .users)
    }

    func encode(to encoder: Encoder) throws {
        var container = encoder.container(keyedBy: CodingKeys.self)
        try container.encode(id, forKey: .id)
        try container.encode(name, forKey: .name)
        try container.encode(picture, forKey: .picture)
        try container.encode(currency, forKey: .currency)
        try container.encode(users, forKey: .users)
    }
}
