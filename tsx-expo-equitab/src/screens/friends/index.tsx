import IconHeaderButton from "@/components/buttons/icon-header-button"
import { useNavigation } from "@react-navigation/native"
import { useEffect } from "react"
import { HeaderButtons, Item } from "react-navigation-header-buttons"
import { FriendsTabNavigation } from "./navigation"

export default function FriendsScreen() {
	const navigation = useNavigation()

	useEffect(() => {
		navigation.setOptions({
			headerShadowVisible: false,
			headerRight: () => (
				<HeaderButtons HeaderButtonComponent={IconHeaderButton}>
					<Item
						title="Add Friend"
						iconName="person-add"
						onPress={() => {
							navigation.navigate("AddFriends")
						}}
					/>
				</HeaderButtons>
			),
		})
	}, [navigation])

	return <FriendsTabNavigation />
}
