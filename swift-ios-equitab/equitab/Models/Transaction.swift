import Foundation
import SwiftData

@Model
final class Transaction: Codable {
    @Attribute(.unique) var id: Int
    var name: String
    var cost: Double
    var location: String
    var datetime: Date
    var category: Category
    var payer: User
    var owers: [User]
    var ledger: Ledger?
    var products: [Product]?
    var productCount: Int?

    private enum CodingKeys: String, CodingKey {
        case id, name, cost, location, datetime, category, payer, owers, ledger, products
        case productCount = "product_count"
    }

    init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        id = try container.decode(Int.self, forKey: .id)
        name = try container.decode(String.self, forKey: .name)
        cost = try container.decode(Double.self, forKey: .cost)
        location = try container.decode(String.self, forKey: .location)
        datetime = try container.decode(Date.self, forKey: .datetime)
        category = try container.decode(Category.self, forKey: .category)
        payer = try container.decode(User.self, forKey: .payer)
        owers = try container.decode([User].self, forKey: .owers)
        ledger = try container.decodeIfPresent(Ledger.self, forKey: .ledger)
        products = try container.decodeIfPresent([Product].self, forKey: .products)
        productCount = try container.decodeIfPresent(Int.self, forKey: .productCount)
    }

    func encode(to encoder: Encoder) throws {
        var container = encoder.container(keyedBy: CodingKeys.self)
        try container.encode(id, forKey: .id)
        try container.encode(name, forKey: .name)
        try container.encode(cost, forKey: .cost)
        try container.encode(location, forKey: .location)
        try container.encode(datetime, forKey: .datetime)
        try container.encode(category, forKey: .category)
        try container.encode(payer, forKey: .payer)
        try container.encode(owers, forKey: .owers)
        try container.encode(ledger, forKey: .ledger)
        try container.encode(products, forKey: .products)
        try container.encode(productCount, forKey: .productCount)
    }
}
