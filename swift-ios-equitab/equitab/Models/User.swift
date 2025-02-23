//
//  User.swift
//  equitab
//
//  Created by Zechariah Tan on 4/1/25.
//

import Foundation
import SwiftData

@Model
class User: Codable {
    @Attribute(.unique) var id: Int
    var username: String?
    var phoneNumber: String?
    var picture: String?
    var aggregate: Int?

    private enum CodingKeys: String, CodingKey {
        case id, username, picture, aggregate
        case phoneNumber = "phone_number"
    }

    required init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        id = try container.decode(Int.self, forKey: .id)
        username = try container.decodeIfPresent(String.self, forKey: .username)
        phoneNumber = try container.decodeIfPresent(String.self, forKey: .phoneNumber)
        picture = try container.decodeIfPresent(String.self, forKey: .picture)
        aggregate = try container.decodeIfPresent(Int.self, forKey: .aggregate)
    }

    func encode(to encoder: Encoder) throws {
        var container = encoder.container(keyedBy: CodingKeys.self)
        try container.encode(id, forKey: .id)
        try container.encode(username, forKey: .username)
        try container.encode(phoneNumber, forKey: .phoneNumber)
        try container.encode(picture, forKey: .picture)
    }
}
