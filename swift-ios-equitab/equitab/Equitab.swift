//
//  Equitab.swift
//  equitab
//
//  Created by Zechariah Tan on 4/1/25.
//

import SwiftUI

struct Equitab: View {
    @State private var selection: Tab = .ledgers

    init() {
        LoginOperation(
            request: LoginRequest(
                username: "zS1L3NT", password: "P@ssw0r",
                deviceName: "iPhone 16"
            )
        ).execute { response in
            switch response {
            case .success(let data):
                print("Data: \(data)")
            case .failure(let error):
                print("Error: \(error)")
            }
        }
    }

    enum Tab {
        case ledgers
        case friends
        case settings
    }

    var body: some View {
        TabView(selection: $selection) {
            LedgerListView()
                .tabItem {
                    Label("Ledgers", systemImage: "banknote")
                }
                .tag(Tab.ledgers)

            FriendListView()
                .tabItem {
                    Label("Friends", systemImage: "person")
                }
                .tag(Tab.friends)

            SettingListView()
                .tabItem {
                    Label("Settings", systemImage: "gearshape")
                }
                .tag(Tab.settings)
        }
    }
}

#Preview {
    Equitab()
}
