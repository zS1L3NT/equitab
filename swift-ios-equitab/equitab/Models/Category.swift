import Foundation
import SwiftData

@Model
final class Category: Decodable {
    @Attribute(.unique) var id: Int
    var name: String
    var picture: String

    struct Reference: Encodable {
        var id: Int
    }

    enum CodingKeys: String, CodingKey {
        case id, name, picture
    }

    init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        id = try container.decode(Int.self, forKey: .id)
        name = try container.decode(String.self, forKey: .name)
        picture = try container.decode(String.self, forKey: .picture)
    }
}
