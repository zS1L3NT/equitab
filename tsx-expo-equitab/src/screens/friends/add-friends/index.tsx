import { Header } from "@react-navigation/elements"
import { Text, View } from "react-native"

export default function AddFriendsScreen() {
	return (
		<>
			<Header title="Add Friends" back={{ title: "Friends", href: "" }} />
			<View>
				<Text>Add Friends</Text>
			</View>
		</>
	)
}
