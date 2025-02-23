//
//  equitabApp.swift
//  equitab
//
//  Created by Zechariah Tan on 3/1/25.
//

import SwiftData
import SwiftUI

@main
struct EquitabApp: App {
    var body: some Scene {
        WindowGroup {
            Equitab().modelContainer(for: [
                User.self,
                Ledger.self,
                Transaction.self,
                Product.self,
                Currency.self,
                Category.self,
            ])
        }
    }
}
