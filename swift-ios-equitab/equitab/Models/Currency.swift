import Foundation
import SwiftData

@Model
final class Currency: Decodable {
    @Attribute(.unique) var code: String
    var name: String
    var symbol: String
    var decimals: Int

    struct Reference {
        var code: String
    }

    enum CodingKeys: String, CodingKey {
        case code, name, symbol, decimals
    }

    init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        code = try container.decode(String.self, forKey: .code)
        name = try container.decode(String.self, forKey: .name)
        symbol = try container.decode(String.self, forKey: .symbol)
        decimals = try container.decode(Int.self, forKey: .decimals)
    }
}
