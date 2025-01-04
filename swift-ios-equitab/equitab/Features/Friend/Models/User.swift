//
//  User.swift
//  equitab
//
//  Created by Zechariah Tan on 4/1/25.
//

import Foundation

struct User: Decodable {
    let id: Int
    let username: String
    let phoneNumber: String
    let phoneNumberVerifiedAt: Date?
    let picturePath: String
    let createdAt: Date
    let updatedAt: Date?
    
    private enum CodingKeys: String, CodingKey {
        case id
        case username
        case phoneNumber = "phone_number"
        case phoneNumberVerifiedAt = "phone_number_verified_at"
        case picturePath = "picture_path"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
