import Foundation
import SwiftData

@Model
final class Product: Codable {
    @Attribute(.unique) var id: Int
    var name: String
    var index: Int
    var quantity: Int
    var cost: Double
    var owers: [User]
    var transaction: Transaction?

    private enum CodingKeys: String, CodingKey {
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
        transaction = try container.decode(Transaction.self, forKey: .transaction)
    }

    func encode(to encoder: Encoder) throws {
        var container = encoder.container(keyedBy: CodingKeys.self)
        try container.encode(id, forKey: .id)
        try container.encode(name, forKey: .name)
        try container.encode(index, forKey: .index)
        try container.encode(quantity, forKey: .quantity)
        try container.encode(cost, forKey: .cost)
        try container.encode(owers, forKey: .owers)
        try container.encode(transaction, forKey: .transaction)
    }
}
