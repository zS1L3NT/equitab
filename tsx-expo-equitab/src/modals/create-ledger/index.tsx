import IconHeaderButton from "@/components/buttons/icon-header-button"
import { useNavigation } from "@react-navigation/native"
import { useEffect } from "react"
import { Platform, Text, View } from "react-native"
import { HeaderButtons, Item } from "react-navigation-header-buttons"

export default function CreateLedgerModal() {
	const navigation = useNavigation()

	useEffect(() => {
		navigation.setOptions({
			headerTitle: "Create Ledger",
			headerLeft:
				Platform.OS === "ios"
					? () => (
							<HeaderButtons HeaderButtonComponent={IconHeaderButton}>
								<Item title="Cancel" onPress={() => navigation.goBack()} />
							</HeaderButtons>
						)
					: undefined,
		})
	}, [navigation])

	return (
		<View>
			<Text>Create Ledger</Text>
		</View>
	)
}
