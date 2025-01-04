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
//            LedgersListView()
//                .tabItem {
//                    Label("Ledgers", systemImage: "ledger")
//                }
//                .tag(Tab.ledgers)
//            
//            FriendsTabView()
//                .tabItem {
//                        Label("Friends", systemImage: "person.circle")
//
//                }
//                .tag(Tab.friends)
//            
//            SettingsView()
//                .tabItem {
//                    Label("Settings", systemImage: "gearshape")
//                }
//                .tag(Tab.settings)
        }
    }
}

#Preview {
    Equitab()
}
