import SwiftUI

struct FriendAddView: View {
    @Environment(\.dismiss) var dismiss
    @State private var query = ""

    var body: some View {
        NavigationStack {
            Text("Add Friend")
                .navigationTitle("Add Friend")
                .navigationBarTitleDisplayMode(.inline)
                .toolbar {
                    ToolbarItem(placement: .topBarLeading) {
                        Button(action: {
                            dismiss()
                        }) {
                            Text("Close")
                                .foregroundStyle(.blue)
                        }
                    }
                }
                .searchable(text: $query)
        }
    }
}

#Preview {
    FriendAddView()
}
