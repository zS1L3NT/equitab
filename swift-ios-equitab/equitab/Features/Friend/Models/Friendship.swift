//
//  Friendship.swift
//  equitab
//
//  Created by Zechariah Tan on 4/1/25.
//

import Foundation

struct Friendship: Decodable {
    let id: Int
    let fromUserId: Int
    let toUserId: Int
    let status: Status
    let createdAt: Date
    let updatedAt: Date
    
    enum Status: String, Decodable {
        case pending
        case accepted
        case rejected
    }

    private enum CodingKeys: String, CodingKey {
        case id
        case fromUserId = "from_user_id"
        case toUserId = "to_user_id"
        case status
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
