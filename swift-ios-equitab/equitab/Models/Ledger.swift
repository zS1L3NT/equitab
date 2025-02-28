import Foundation
import SwiftData

@Model
final class Ledger: Decodable {
    @Attribute(.unique) var id: Int
    var name: String
    var picture: String
    var currency: Currency
    var users: [User]
    @Transient var aggregate: Double?

    struct Reference: Encodable {
        var id: Int
    }

    enum CodingKeys: String, CodingKey {
        case id, name, picture, currency, users, aggregate
    }

    init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        id = try container.decode(Int.self, forKey: .id)
        name = try container.decode(String.self, forKey: .name)
        picture = try container.decode(String.self, forKey: .picture)
        currency = try container.decode(Currency.self, forKey: .currency)
        users = try container.decode([User].self, forKey: .users)
        aggregate = try container.decodeIfPresent(Double.self, forKey: .aggregate)
    }
}
