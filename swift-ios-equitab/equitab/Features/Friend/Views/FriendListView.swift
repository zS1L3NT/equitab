//
//  FriendTabView.swift
//  equitab
//
//  Created by Zechariah Tan on 4/1/25.
//

import SwiftUI

struct FriendListView: View {
    @State private var query = ""
    @State private var filter: Filter = .all
    @State private var isAddingFriend = false

    enum Filter {
        case all
        case outgoing
        case incoming
    }

    var body: some View {
        NavigationSplitView {
            Text("Friends")
                .navigationTitle("Friends")
                .toolbar {
                    ToolbarItem(placement: .primaryAction) {
                        Menu {
                            Section {
                                Button(action: {
                                    isAddingFriend = true
                                }) {
                                    Label(
                                        "Add Friends",
                                        systemImage: "person.badge.plus")
                                }
                            }

                            Picker(selection: $filter) {
                                Label("All", systemImage: "list.bullet")
                                    .tag(Filter.all)
                                Label("Outgoing", systemImage: "clock")
                                    .tag(Filter.outgoing)
                                Label("Incoming", systemImage: "questionmark")
                                    .tag(Filter.incoming)
                            } label: {
                                Label(
                                    "Filter",
                                    systemImage: "line.3.horizontal.decrease")
                            }
                        } label: {
                            Label("Menu", systemImage: "ellipsis.circle")
                        }
                    }
                }
                .searchable(text: $query)
                .sheet(isPresented: $isAddingFriend) {
                    FriendAddView()
                }
        } detail: {
            Text("Friends")
        }
    }
}

#Preview {
    FriendListView()
}
