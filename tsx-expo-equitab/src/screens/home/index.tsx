import IconHeaderButton from "@/components/buttons/icon-header-button"
import { useNavigation } from "@react-navigation/native"
import { useEffect } from "react"
import { HeaderButtons, Item } from "react-navigation-header-buttons"
import { HomeTabNavigation } from "./navigation"

export default function HomeScreen() {
	const navigation = useNavigation()

	useEffect(() => {
		navigation.setOptions({
			headerShadowVisible: false,
			headerRight: () => (
				<HeaderButtons HeaderButtonComponent={IconHeaderButton}>
					<Item
						title="Create Ledger"
						iconName="add"
						onPress={() => {
							navigation.navigate("CreateLedger")
						}}
					/>
				</HeaderButtons>
			),
		})
	}, [navigation])

	return <HomeTabNavigation />
}
