//
//  Category.swift
//  equitab
//
//  Created by Zechariah Tan on 23/2/25.
//

import Foundation
import SwiftData

@Model
final class Category: Codable {
    @Attribute(.unique) var id: Int
    var name: String
    var picture: String

    private enum CodingKeys: String, CodingKey {
        case id, name, picture
    }

    init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        id = try container.decode(Int.self, forKey: .id)
        name = try container.decode(String.self, forKey: .name)
        picture = try container.decode(String.self, forKey: .picture)
    }

    func encode(to encoder: Encoder) throws {
        var container = encoder.container(keyedBy: CodingKeys.self)
        try container.encode(id, forKey: .id)
        try container.encode(name, forKey: .name)
        try container.encode(picture, forKey: .picture)
    }
}
