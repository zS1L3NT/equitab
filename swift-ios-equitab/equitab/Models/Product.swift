import Foundation
import SwiftData

@Model
final class Product: Decodable {
    @Attribute(.unique) var id: Int
    var name: String
    var index: Int
    var quantity: Int
    var cost: Double
    var owers: [User]
    var transaction: Transaction?

    struct Reference: Encodable {
        var id: Int
    }

    enum CodingKeys: String, CodingKey {
        case id, name, index, quantity, cost, owers, transaction
    }

    init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        id = try container.decode(Int.self, forKey: .id)
        name = try container.decode(String.self, forKey: .name)
        index = try container.decode(Int.self, forKey: .index)
        quantity = try container.decode(Int.self, forKey: .quantity)
        cost = try container.decode(Double.self, forKey: .cost)
        owers = try container.decode([User].self, forKey: .owers)
        transaction = try container.decodeIfPresent(Transaction.self, forKey: .transaction)
    }
}
