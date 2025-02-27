import Foundation
import SwiftData

@Model
final class Currency: Codable {
    @Attribute(.unique) var code: String
    var name: String
    var symbol: String
    var decimals: Int

    private enum CodingKeys: String, CodingKey {
        case code, name, symbol, decimals
    }

    init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        code = try container.decode(String.self, forKey: .code)
        name = try container.decode(String.self, forKey: .name)
        symbol = try container.decode(String.self, forKey: .symbol)
        decimals = try container.decode(Int.self, forKey: .decimals)
    }

    func encode(to encoder: Encoder) throws {
        var container = encoder.container(keyedBy: CodingKeys.self)
        try container.encode(code, forKey: .code)
        try container.encode(name, forKey: .name)
        try container.encode(symbol, forKey: .symbol)
        try container.encode(decimals, forKey: .decimals)
    }
}
