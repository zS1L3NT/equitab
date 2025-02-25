//
//  Equitab.swift
//  equitab
//
//  Created by Zechariah Tan on 4/1/25.
//

import SwiftUI

struct Equitab: View {
    @State private var selection: Tab = .ledgers

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
